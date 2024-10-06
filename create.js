#!/usr/bin/env node

const path = require('path');
const { exec } = require('child_process');
const degit = require('degit');

const projectName = process.argv[2];

if (!projectName) {
    console.error('Please provide a project name.');
    process.exit(1);
}

// Ruta del nuevo proyecto
const projectPath = path.join(process.cwd(), projectName);

// Crear la carpeta del nuevo proyecto y descargar la plantilla
(async () => {
    try {
        // Crea un clonador degit apuntando a tu repositorio de plantillas
        const emitter = degit('tu-usuario/tu-repo-plantilla'); // Cambia por la URL de tu repositorio de plantilla

        // Descargar los archivos de la plantilla en la carpeta del proyecto
        await emitter.clone(projectPath);

        console.log(`Project "${projectName}" created successfully!`);

        // Opcional: Instalar dependencias automáticamente
        exec(`cd ${projectPath} && npm install`, (err, stdout, stderr) => {
            if (err) {
                console.error('Error installing dependencies:', err);
                return;
            }
            console.log('Dependencies installed successfully.');
            console.log(stdout);
        });
    } catch (err) {
        console.error('Error creating project:', err);
        process.exit(1);
    }
})();
