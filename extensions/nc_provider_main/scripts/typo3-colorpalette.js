import fs from 'fs';
import handlebars from 'handlebars';

export default function () {

  console.log('Build Colorpalette');

  // Read the _colors.scss file
  const cssData = fs.readFileSync('./Resources/Private/Frontend/Scss/abstracts/_coreTokenColors.scss', 'utf8');

  // Split the string by line breaks and remove empty lines
  const lines = cssData.split('\n').filter(line => line.trim() !== '');

  // Initialize an empty array to store the result
  const colorArray = [];

  // Iterate over each line and extract the color value
  lines.forEach(line => {
    const match = line.match(/\$(.*):(.*)/);
    if (match) {
      const key = match[1].trim();
      const value = match[2].trim();
      colorArray.push({'key': key, 'value': value});

      console.log(key, value);
    }
  });

  // merge the colorArray with the handlebars template
  const template = handlebars.compile(fs.readFileSync('./scripts/Templates/Colorpalette.hbs', 'utf8'));
  const data = {colors: colorArray};
  const result = template(data);

  // write the result to a file
  fs.writeFileSync('./Resources/Private/Partials/Base/Colorpalette.html', result, 'utf8');

  console.log('./Resources/Private/Partials/Base/Colorpalette.html built\n');
}
