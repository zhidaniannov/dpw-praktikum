const fs = require("fs");
const path = require("path");
const sharp = require("sharp");

// folder sumber (ubah sesuai kebutuhan)
const inputFolder = "./frontend/images";
// folder output
const outputFolder = "./frontend/images/";

// buat folder output kalau belum ada
if (!fs.existsSync(outputFolder)) {
    fs.mkdirSync(outputFolder, { recursive: true });
}

// baca semua file di folder
fs.readdirSync(inputFolder).forEach(file => {
    const ext = path.extname(file).toLowerCase();

    // filter hanya jpg/png
    if (ext === ".jpg" || ext === ".jpeg" || ext === ".png") {
        const inputPath = path.join(inputFolder, file);
        const outputPath = path.join(
            outputFolder,
            path.parse(file).name + ".webp"
        );

        sharp(inputPath)
            .webp({ quality: 80 })
            .toFile(outputPath)
            .then(() => {
                console.log(`✔ Converted: ${file}`);
            })
            .catch(err => {
                console.error(`✖ Error: ${file}`, err);
            });
    }
});