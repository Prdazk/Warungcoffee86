<style>
/* ===== MODAL WRAPPER ===== */
.custom-modal {
    background: #1b1b1b;
    color: #fff;
    border-radius: 14px;
    border: 1px solid #3a3a3a;
    box-shadow: 0 0 20px rgba(0,0,0,0.6);
    overflow: hidden;
    padding-bottom: 10px;
}

/* Perkecil ukuran modal */
#modalTambah .modal-dialog {
    max-width: 650px;
}

/* ===== TITLE ===== */
#modalTambah .modal-title {
    font-size: 20px;
    font-weight: 700;
    color: #c18b4a;
    width: 100%;
    text-align: center;
    letter-spacing: 1px;
    text-transform: uppercase;
}

/* ===== LABEL ===== */
#modalTambah .form-label {
    color: #c18b4a;
    font-size: 13px;
    margin-bottom: 4px;
}

/* ===== INPUT, SELECT ===== */
#modalTambah .custom-input {
    background: rgba(30,30,30,0.9) !important;
    border-radius: 10px;
    border: 1px solid #444;
    color: #fff !important;
    padding: 8px 10px;
    font-size: 14px;
    transition: .3s ease;
    height: 38px;
}

#modalTambah .custom-input:focus {
    border-color: #c18b4a;
    box-shadow: 0 0 6px rgba(193,139,74,0.7);
    background: rgba(45,45,45,0.9) !important;
}

#modalTambah .custom-input:hover {
    border-color: #c18b4a;
}

/* Placeholder */
#modalTambah .custom-input::placeholder {
    color: rgba(255,255,255,0.65) !important;
}

/* Input file */
#modalTambah input[type=file] {
    padding: 7px;
}

/* ===== BUTTON SAVE ===== */
#modalTambah .custom-btn-save {
    background: #c18b4a;
    border-radius: 8px;
    padding: 8px 30px;
    font-weight: 600;
    color: #fff;
    transition: .3s;
    border: none;
    font-size: 14px;
}
#modalTambah .custom-btn-save:hover {
    background: #996d39;
}

/* ===== BUTTON CANCEL ===== */
#modalTambah .custom-btn-cancel {
    background: #5b5b5b;
    border-radius: 8px;
    padding: 8px 30px;
    font-weight: 600;
    color: #fff;
    transition: .3s;
    border: none;
    font-size: 14px;
}
#modalTambah .custom-btn-cancel:hover {
    background: #3b3b3b;
}

/* ===== CLOSE BUTTON ===== */
#modalTambah .btn-close {
    filter: invert(100%);
    opacity: .7;
}
#modalTambah .btn-close:hover {
    opacity: 1;
}

/* Perkecil spacing antar form */
#modalTambah .row.g-4 {
    row-gap: 15px !important;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 576px) {
    #modalTambah .custom-btn-save,
    #modalTambah .custom-btn-cancel {
        width: 47%;
    }
}
</style>


