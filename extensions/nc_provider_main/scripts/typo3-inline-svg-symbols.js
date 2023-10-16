import fs from 'fs';
import path from 'path';
import handlebars from 'handlebars';

export default function () {

  console.log('Build InlineSvgSymbols');

  // Path to the svg library
  const svgLibraryPath = './Resources/Private/Frontend/SvgLibrary/';

  // read all files from ./Resources/Private/Frontend/SvgLibrary
  const files = fs.readdirSync(svgLibraryPath, {encoding:'utf8', withFileTypes: false });

  // filter all svg files
  const svgFiles = files.filter(file => path.extname(file) === '.svg');

  // Initialize an empty array to store the result
  const svgArray = [];

  // load each file and extract the svg content
  svgFiles.forEach(file => {

    // read the file and remove line breaks
    const svgContent = fs.readFileSync(svgLibraryPath + file, 'utf8').replace(/(\r\n|\n|\r)/gm, '');

    // extract filename without extension
    const filenameWithoutExtension = path.basename(file, '.svg');

    // get viewbox attribute from string
    const viewBox = svgContent.match(/viewBox="([^"]*)"/)[1];

    // extract svg content
    const svgContentWithoutSvgTag = svgContent.replace(/<svg[^>]*>/, '').replace(/<\/svg>/, '');

    if( viewBox || svgContentWithoutSvgTag ) {
      svgArray.push({'name': filenameWithoutExtension, 'viewBox': viewBox, 'svgContent': svgContentWithoutSvgTag});
      console.log(file);
    }

  });

  // merge the svgArray with the handlebars template
  const template = handlebars.compile(fs.readFileSync('./scripts/Templates/InlineSvgSymbols.hbs', 'utf8'));
  const data = {svgSymbols: svgArray};
  const result = template(data);

  // write the result to a file
  fs.writeFileSync('./Resources/Private/Partials/Base/Symbols.html', result, 'utf8');

  console.log('./Resources/Private/Partials/Base/Symbols.html built\n');
}
