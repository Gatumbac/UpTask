import path from 'path';
import fs from 'fs';
import { glob } from 'glob';
import { src, dest, watch, series } from 'gulp';
import * as dartSass from 'sass';
import gulpSass from 'gulp-sass';
import sharp from 'sharp';
import terser from 'gulp-terser';

const sass = gulpSass(dartSass);

//export default series(images, js, css, dev);
export default series(js, css, dev);

export function js2( done ) {
    src('src/js/**/*.js', {sourcemaps: true})
        .pipe(terser())
        .pipe(dest('public/build/js', {sourcemaps: '.'}));
    done();
}

export function js(done) {
    src('src/js/**/*.js', { sourcemaps: true })
        .pipe(terser())
        .on('error', (err) => console.error(err)) // Log errors
        .pipe(dest('public/build/js', { sourcemaps: '.' }))
        .on('end', () => console.log('JavaScript files processed!')); // Log success
    done();
}

export function css( done ) {
    src('src/scss/app.scss', {sourcemaps: true}) 
        .pipe(sass.sync({
            style: 'compressed'
        }).on('error', sass.logError)) 
        .pipe(dest('./public/build/css', {sourcemaps: '.'})); 
    done();
}

export function dev() {
    watch('src/scss/**/*.scss', css);
    watch('src/js/**/*.js', js);
    watch('src/img/**/*.{png,jpg}', images);
}

export async function crop( done ) {
    const inputFolder = 'src/img/full'
    const outputFolder = 'src/img/thumb';
    const width = 250;
    const height = 180;
    if (!fs.existsSync(outputFolder)) {
        fs.mkdirSync(outputFolder, { recursive: true })
    }
    const images = fs.readdirSync(inputFolder).filter(file => {
        return /\.(jpg)$/i.test(path.extname(file));
    });
    try {
        images.forEach(file => {
            const inputFile = path.join(inputFolder, file)
            const outputFile = path.join(outputFolder, file)
            sharp(inputFile) 
                .resize(width, height, {
                    position: 'centre'
                })
                .toFile(outputFile)
        });

        done()
    } catch (error) {
        console.log(error)
    }
}


export async function images( done ) {
    const srcDir = './src/img';
    const buildDir = './public/build/img';
    const images =  await glob('./src/img/**/*.{jpg,png}')

    images.forEach(file => {
        const relativePath = path.relative(srcDir, path.dirname(file));
        const outputSubDir = path.join(buildDir, relativePath);
        processImages(file, outputSubDir);
    });
    done();
}

function processImages(file, outputSubDir) {
    if (!fs.existsSync(outputSubDir)) {
        fs.mkdirSync(outputSubDir, { recursive: true })
    }
    const baseName = path.basename(file, path.extname(file))
    const extName = path.extname(file)
    const outputFile = path.join(outputSubDir, `${baseName}${extName}`)
    const outputFileWebp = path.join(outputSubDir, `${baseName}.webp`)
    const outputFileAvif = path.join(outputSubDir, `${baseName}.avif`)


    const options = { quality: 80 }
    sharp(file).jpeg(options).toFile(outputFile)
    sharp(file).webp(options).toFile(outputFileWebp)
    sharp(file).avif(options).toFile(outputFileAvif)
}