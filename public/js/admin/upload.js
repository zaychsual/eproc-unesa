var pdf = false;

function getFileExtension(filename) {
    var ext = /^.+\.([^.]+)$/.exec(filename);
    return ext == null ? "" : ext[1];
}

function ValidateImg(oInput) {
    var _validFileExtensions = [".jpg", ".jpeg", ".png"];
    if (oInput.type == "file") {
        var sFileName = oInput.value;
        if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    pdf = true;
                    break;
                }
            }

            if (!blnValid) {
                swal("Oops...", "File yang diupload harus *.jpg, *.jpeg, *.png", "error");
                oInput.value = "";
                pdf = false;
                return false;
            }
        }
    }
    return true;
}

function checkFileSizeImg(inputFile) {
    var max = 1024000; // 1024KB

    if (inputFile.files && inputFile.files[0].size > max) {
        swal("Oops...", "File terlalu besar (lebih dari 1MB) ! Mohon kompres/perkecil ukuran file", "error");
        inputFile.value = null; // Clear the field.
    }
}

function ValidateFile(oInput) {
    var _validFileExtensions = [".jpg", ".jpeg", ".png", ".doc", ".docx", ".pdf", ".xls", ".xlsx", ".ppt", ".pptx", ".mp3", ".mp4", ".mkv", "mpeg"];
    if (oInput.type == "file") {
        var sFileName = oInput.value;
        if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    pdf = true;
                    break;
                }
            }

            if (!blnValid) {
                swal("Oops...", "Ekstensi File tidak diperbolehkan", "error");
                oInput.value = "";
                pdf = false;
                return false;
            }
        }
    }
    return true;
}

function checkFileSizeFile(inputFile) {
    var max = 3145728; // 3MB

    if (inputFile.files && inputFile.files[0].size > max) {
        swal("Oops...", "File terlalu besar (lebih dari 3MB) ! Mohon kompres/perkecil ukuran file", "error");
        inputFile.value = null; // Clear the field.
    }
}