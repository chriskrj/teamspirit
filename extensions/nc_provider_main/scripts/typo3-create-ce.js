import * as readline from 'node:readline/promises';
import {stdin as input, stdout as output} from 'node:process';
import fs from 'fs';
import handlebars from 'handlebars';

handlebars.registerHelper('lowercase', function (aString) {
  return aString.toLowerCase();
});

async function createCe() {

  const rl = readline.createInterface({ input, output });

  const ceName = await rl.question('Name of Content Element in UpperCamelCase: ');

  console.log(`Create Content Element: ${ceName}`);

  createTsConfigFile(ceName);
  createTyposcriptFile(ceName);
  createTcaFile(ceName);
  createTemplateFile(ceName);
  createIconFile(ceName);

  console.log('Please add the icon to the /Configuration/Icons.php file');


  rl.close();
}

function createTsConfigFile(ceName) {
  // create TsConfigFile
  const template = handlebars.compile(fs.readFileSync('./scripts/Templates/CeTsConfig.hbs', 'utf8'));
  const data = {ceName: ceName};
  const result = template(data);

  const filePath = `./Configuration/TsConfig/Page/ContentElements/${ceName}.tsconfig`;

  if (fs.existsSync(filePath)) {
    console.error(`[ERROR] File ${filePath} already exists!`);
  } else {
    console.log(`Create file ${filePath}`);
    fs.writeFileSync(filePath, result, 'utf8');
  }
}

function createTyposcriptFile(ceName) {
  // create TsConfigFile
  const template = handlebars.compile(fs.readFileSync('./scripts/Templates/CeTyposcript.hbs', 'utf8'));
  const data = {ceName: ceName};
  const result = template(data);

  const filePath = `./Configuration/TypoScript/Setup/ContentElements/${ceName}.typoscript`;

  if (fs.existsSync(filePath)) {
    console.error(`[ERROR] File ${filePath} already exists!`);
  } else {
    console.log(`Create file ${filePath}`);
    fs.writeFileSync(filePath, result, 'utf8');
  }
}

function createTcaFile(ceName) {
  // create TsConfigFile
  const template = handlebars.compile(fs.readFileSync('./scripts/Templates/CeTca.hbs', 'utf8'));
  const data = {ceName: ceName};
  const result = template(data);

  const filePath = `./Configuration/TCA/Overrides/tt_content_${ceName.toLowerCase()}.php`;

  if (fs.existsSync(filePath)) {
    console.error(`[ERROR] File ${filePath} already exists!`);
  } else {
    console.log(`Create file ${filePath}`);
    fs.writeFileSync(filePath, result, 'utf8');
  }
}

function createTemplateFile(ceName) {
  // create TsConfigFile
  const template = handlebars.compile(fs.readFileSync('./scripts/Templates/CeTemplate.hbs', 'utf8'));
  const data = {ceName: ceName};
  const result = template(data);

  const filePath = `./Resources/Private/Templates/ContentElements/${ceName}.html`;

  if (fs.existsSync(filePath)) {
    console.error(`[ERROR] File ${filePath} already exists!`);
  } else {
    console.log(`Create file ${filePath}`);
    fs.writeFileSync(filePath, result, 'utf8');
  }
}

function createIconFile(ceName) {
  // create TsConfigFile
  const template = handlebars.compile(fs.readFileSync('./scripts/Templates/CeIcon.hbs', 'utf8'));
  const data = {ceName: ceName};
  const result = template(data);

  const filePath = `./Resources/Public/Backend/ContentElements/${ceName}.svg`;

  if (fs.existsSync(filePath)) {
    console.error(`[ERROR] File ${filePath} already exists!`);
  } else {
    console.log(`Create file ${filePath}`);
    fs.writeFileSync(filePath, result, 'utf8');
  }
}

createCe();
