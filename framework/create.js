#!/usr/bin/env node

const fs = require('fs');
const path = require('path');

const projectName = process.argv[2];

if (!projectName) {
    console.error('Please provide a project name.');
    process.exit(1);
}

// Ruta del nuevo proyecto
const projectPath = path.join(process.cwd(), projectName);

// Crear la carpeta del nuevo proyecto
fs.mkdir(projectPath, { recursive: true }, (err) => {
    if (err) {
        console.error('Error creating project directory:', err);
        process.exit(1);
    }

    // Aquí puedes agregar los archivos y carpetas que deseas crear en el nuevo proyecto
    const indexFilePath = path.join(projectPath, 'index.php');
    fs.writeFile(indexFilePath, '<?php\n\n// Your code here\n', (err) => {
        if (err) {
            console.error('Error creating index.php:', err);
            process.exit(1);
        }

        console.log(`Project "${projectName}" created successfully!`);
    });
});
