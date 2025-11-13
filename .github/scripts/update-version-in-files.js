'use strict'

const replaceInFile = require('replace-in-file')

const { VERSION } = process.env

const replaceInFileWithLog = async (options) => {
  const results = await replaceInFile(options)
  console.info('Replacement results:', results, 'options: ', options)
}

const run = async () => {
  try {
    await replaceInFileWithLog({
      files: './dev/scss/theme/_banner.scss',
      from: /ver:.*$/m,
      to: `ver: ${VERSION}`,
    })

    await replaceInFileWithLog({
      files: './functions.php',
      from: /@version.*$/m,
      to: `@version ${VERSION}`,
    })

    await replaceInFileWithLog({
      files: './style.css',
      from: /Version:.*$/m,
      to: `Version: ${VERSION}`,
    })

    await replaceInFileWithLog({
      files: './package.json',
      from: /"version":.*$/m,
      to: `"version": ${VERSION}`,
    })
  } catch (err) {
    console.error('Error occurred:', err)
    process.exit(1)
  }
}

run()
