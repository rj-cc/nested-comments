const preset = require('./vendor/filament/filament/tailwind.config.preset')

module.exports = {
    presets: [preset],
    content: [
        './src/**/*.php',
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
      './vendor/awcodes/filament-tiptap-editor/resources/**/*.blade.php',
    ],
}
