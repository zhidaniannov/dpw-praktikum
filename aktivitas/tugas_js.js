function simpanNama() {
    const nama = document.getElementById("namaInput").value;

    if (nama.trim() === "") {
        alert("Nama tidak boleh kosong!");
        return;
    }

    document.getElementById("pernyataanNama").innerHTML =
        "Nama saya " + nama + ", saya akan mengamalkan Pancasila dan UUD 1945 sebagai Dasar Negara.";

    document.getElementById("modalNama").style.display = "none";
    document.getElementById("mainContent").style.display = "block";
}

function batal() {
    document.getElementById("namaInput").value = "";
}