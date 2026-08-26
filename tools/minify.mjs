/**
 * tools/minify.mjs
 * ------------------------------------------------------------------
 * Minifikasi aset statis TANPA dependency eksternal (offline-friendly):
 *   1. CSS  : public/css/*.css      -> public/css/*.min.css
 *   2. JS   : public/js/*.js        -> public/js/*.min.js  (vendor Filament di-skip)
 *   3. Image: public/images/**      -> dioptimasi in-place + dibuatkan .webp
 *
 * Jalankan: npm run minify
 * Langkah gambar butuh ImageMagick (magick/convert). Kalau tidak ada, otomatis di-skip.
 */
import { readdirSync, readFileSync, writeFileSync, statSync, existsSync } from 'node:fs'
import { join, extname, basename, dirname } from 'node:path'
import { execFileSync } from 'node:child_process'

const ROOT = process.cwd()
const kb = (n) => (n / 1024).toFixed(1) + ' KB'

function walk(dir, exts) {
	if (!existsSync(dir)) return []
	const out = []
	for (const entry of readdirSync(dir, { withFileTypes: true })) {
		const p = join(dir, entry.name)
		if (entry.isDirectory()) out.push(...walk(p, exts))
		else if (exts.includes(extname(entry.name).toLowerCase())) out.push(p)
	}
	return out
}

/* ---------------- 1. CSS minifier ---------------- */
function minifyCss(css) {
	return css
		.replace(/\/\*[\s\S]*?\*\//g, '')
		.replace(/\s+/g, ' ')
		.replace(/\s*([{}:;,>~+])\s*/g, '$1')
		.replace(/;}/g, '}')
		.replace(/(:|\s)0\.(\d)/g, '$1.$2')
		.trim()
}

/* ---------------- 2. JS minifier (konservatif, aman untuk string) ---------------- */
function minifyJs(js) {
	let out = ''
	let i = 0
	const n = js.length
	while (i < n) {
		const c = js[i]
		const next = js[i + 1]
		if (c === '"' || c === "'" || c === '`') {
			const quote = c
			out += c
			i++
			while (i < n) {
				out += js[i]
				if (js[i] === '\\') { out += js[i + 1] ?? ''; i += 2; continue }
				if (js[i] === quote) { i++; break }
				i++
			}
			continue
		}
		if (c === '/' && next === '/') { while (i < n && js[i] !== '\n') i++; continue }
		if (c === '/' && next === '*') { i += 2; while (i < n && !(js[i] === '*' && js[i + 1] === '/')) i++; i += 2; continue }
		if (/\s/.test(c)) {
			let j = i
			while (j < n && /\s/.test(js[j])) j++
			const prev = out[out.length - 1] ?? ''
			const after = js[j] ?? ''
			const word = /[A-Za-z0-9_$]/
			if ((word.test(prev) && word.test(after)) || (prev === ')' && word.test(after))) out += ' '
			i = j
			continue
		}
		out += c
		i++
	}
	return out.trim()
}

/* ---------------- 3. Image optimizer (ImageMagick) ---------------- */
function magickBin() {
	for (const bin of ['magick', 'convert']) {
		try { execFileSync(bin, ['-version'], { stdio: 'ignore' }); return bin } catch { }
	}
	return null
}

function optimizeImages(maxWidth = 900) {
	const bin = magickBin()
	if (!bin) { console.log('  ! ImageMagick tidak ditemukan, langkah gambar di-skip'); return }
	const files = walk(join(ROOT, 'public/images'), ['.png', '.jpg', '.jpeg'])
	let before = 0, after = 0
	for (const file of files) {
		before += statSync(file).size
		const args = [file, '-auto-orient', '-strip', '-resize', `${maxWidth}x${maxWidth}>`]
		if (extname(file).toLowerCase() === '.png') {
			args.push('-define', 'png:compression-level=9', '-colors', '256')
		} else {
			args.push('-quality', '82', '-interlace', 'Plane', '-sampling-factor', '4:2:0')
		}
		args.push(file)
		try { execFileSync(bin, args, { stdio: 'ignore' }) } catch { }
		const webp = join(dirname(file), basename(file, extname(file)) + '.webp')
		try { execFileSync(bin, [file, '-strip', '-quality', '78', '-define', 'webp:method=6', webp], { stdio: 'ignore' }) } catch { }
		after += statSync(file).size
	}
	console.log(`  images : ${files.length} file  ${kb(before)} -> ${kb(after)} (+ versi .webp)`)
}

/* ---------------- runner ---------------- */
console.log('Minifikasi aset...')

for (const file of walk(join(ROOT, 'public/css'), ['.css'])) {
	if (file.includes('.min.') || file.includes('/filament/')) continue
	const src = readFileSync(file, 'utf8')
	const min = minifyCss(src)
	writeFileSync(file.replace(/\.css$/, '.min.css'), min)
	console.log(`  css    : ${basename(file)}  ${kb(src.length)} -> ${kb(min.length)}`)
}

for (const file of walk(join(ROOT, 'public/js'), ['.js'])) {
	if (file.includes('.min.') || file.includes('/filament/')) continue
	const src = readFileSync(file, 'utf8')
	const min = minifyJs(src)
	writeFileSync(file.replace(/\.js$/, '.min.js'), min)
	console.log(`  js     : ${basename(file)}  ${kb(src.length)} -> ${kb(min.length)}`)
}

optimizeImages()
console.log('Selesai.')
