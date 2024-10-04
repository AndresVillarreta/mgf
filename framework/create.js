#!/usr/bin/env node
const fs = require('fs');
const path = require('path');

const projectName = process.argv[2];

if (!projectName) {
  console.error('Please provide a project name.');
  process.exit(1);
}

// Aquí puedes crear la estructura de tu proyecto
const projectDir = path.join(process.cwd(), projectName);

if (fs.existsSync(projectDir)) {
  console.error(`Project ${projectName} already exists.`);
  process.exit(1);
}

// Crear directorio y copiar archivos necesarios
fs.mkdirSync(projectDir);
console.log(`Created project directory: ${projectDir}`);

// Aquí puedes copiar archivos de plantilla o cualquier otra cosa necesaria.

console.log(`Project ${projectName} created successfully!`);
