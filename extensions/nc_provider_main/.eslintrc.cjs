// https://github.com/h5bp/html5-boilerplate/blob/main/.eslintrc.js
// https://github.com/kunalgolani/eslint-config/tree/master/packages/recommended
module.exports = {
    env: {
        browser: true,
        es6: true,
        node: true
    },
    extends: [
        'plugin:vue/vue3-essential',
        'eslint:recommended'
    ],
    parserOptions: {
        sourceType: 'module'
    },
    rules: {
        indent: ['error', 2],
        quotes: ['error', 'single'],
        semi: ['error', 'always'],
        'no-unused-vars': 'off'
    }
};
