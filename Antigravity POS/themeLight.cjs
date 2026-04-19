const fs = require('fs');
const path = require('path');

function walk(dir) {
    let results = [];
    const list = fs.readdirSync(dir);
    list.forEach(function(file) {
        file = dir + '/' + file;
        const stat = fs.statSync(file);
        if (stat && stat.isDirectory()) { 
            results = results.concat(walk(file));
        } else { 
            if (file.endsWith('.blade.php')) results.push(file);
        }
    });
    return results;
}

const files = walk('resources/views');
files.forEach(file => {
    let content = fs.readFileSync(file, 'utf8');
    
    // Replace text colors
    content = content.replace(/text-slate-100/g, 'text-slate-800');
    content = content.replace(/text-slate-200/g, 'text-slate-700');
    content = content.replace(/text-slate-300/g, 'text-slate-700');
    content = content.replace(/text-slate-400/g, 'text-slate-600');
    content = content.replace(/text-slate-500/g, 'text-slate-600');
    content = content.replace(/text-slate-600/g, 'text-slate-400');
    content = content.replace(/text-slate-700/g, 'text-slate-400');
    content = content.replace(/text-white/g, 'text-slate-800');
    
    // Replace background colors
    content = content.replace(/bg-slate-950/g, 'bg-slate-50');
    content = content.replace(/bg-slate-900/g, 'bg-white');
    content = content.replace(/bg-slate-800\/50/g, 'bg-slate-100\/50');
    content = content.replace(/bg-slate-700\/50/g, 'bg-slate-200\/50');
    content = content.replace(/bg-slate-800/g, 'bg-slate-100');
    content = content.replace(/bg-slate-700/g, 'bg-slate-200');

    // Box shadows
    content = content.replace(/shadow-white/g, 'shadow-slate-800');

    // Replace border colors
    content = content.replace(/border-slate-800\/50/g, 'border-slate-200\/80');
    content = content.replace(/border-slate-700\/50/g, 'border-slate-200\/80');
    content = content.replace(/border-slate-700\/30/g, 'border-slate-200\/80');
    content = content.replace(/border-slate-800/g, 'border-slate-200');
    content = content.replace(/border-slate-700/g, 'border-slate-300');
    
    // In layouts/app.blade.php remove class="dark"
    if (file.includes('layouts/app.blade.php') || file.includes('layouts\\app.blade.php')) {
        content = content.replace(/class="dark"/g, '');
    }

    fs.writeFileSync(file, content, 'utf8');
});

console.log('Replaced all tailwind classes for light theme');
