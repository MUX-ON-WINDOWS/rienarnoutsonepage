const fs = require('fs');
const path = require('path');

const root = __dirname;
const dist = path.join(root, 'dist');

// Ensure dist directory exists
fs.mkdirSync(dist, { recursive: true });

// Helper to copy a file if it exists
function copyIfExists(source, target) {
  const relSource = path.relative(root, source);
  const relTarget = path.relative(root, target);
  if (!fs.existsSync(source)) {
    console.warn(`Missing: ${relSource}`);
    return { copied: false, item: relSource, reason: 'missing' };
  }
  fs.copyFileSync(source, target);
  console.log(`Copied ${relSource} -> ${relTarget}`);
  return { copied: true, item: relSource };
}

const copied = [];
const files = [
  ['index.html', 'index.html'],
  ['style.css', 'style.css'],
  ['script.js', 'script.js'],
  ['mobile.js', 'mobile.js'],
];

const statuses = [];
for (const [src, dest] of files) {
  const result = copyIfExists(path.join(root, src), path.join(dist, dest));
  statuses.push({ src, copied: result.copied, reason: result.reason || 'ok' });
  if (result.copied) copied.push(src);
}

// Copy asset folders
function copyDirIfExists(sourceDir, targetDir) {
  const relSource = path.relative(root, sourceDir);
  const relTarget = path.relative(root, targetDir);
  if (!fs.existsSync(sourceDir)) {
    console.warn(`Missing dir: ${relSource}`);
    return { copied: false, item: relSource, reason: 'missing' };
  }
  fs.mkdirSync(targetDir, { recursive: true });
  for (const entry of fs.readdirSync(sourceDir)) {
    const src = path.join(sourceDir, entry);
    const dest = path.join(targetDir, entry);
    const stats = fs.statSync(src);
    if (stats.isDirectory()) {
      fs.mkdirSync(dest, { recursive: true });
      copyDirIfExists(src, dest);
    } else {
      fs.copyFileSync(src, dest);
    }
  }
  console.log(`Copied ${relSource} -> ${relTarget}`);
  return { copied: true, item: relSource };
}

const dirs = ['keramiek', 'brons', 'logo', 'img'];
for (const dir of dirs) {
  const result = copyDirIfExists(path.join(root, dir), path.join(dist, dir));
  statuses.push({ src: dir, copied: result.copied, reason: result.reason || 'ok' });
  if (result.copied) copied.push(dir);
}

fs.writeFileSync(
  path.join(dist, 'build.log'),
  `Copied: ${copied.join(', ')}\nStatus: ${JSON.stringify(statuses, null, 2)}\n`,
  'utf8'
);

console.log('Build complete.');
