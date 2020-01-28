import $ from 'jquery';
import SmoothScroll from 'smooth-scroll';

let forms = {

    load(){
        $(document).ready(function () {
            forms.loaded();
        });
    },

    loaded() {
        $('input[type=file]').on("change", function (e) {
            if (typeof (e.target.files[0]) === "undefined") {
                $(this).closest('.input-file-section').children('.file-name').html("Aucun fichier");
            } else {
                let ext = e.target.files[0].name.slice(e.target.files[0].name.lastIndexOf('.') + 1);
                let fileName = e.target.files[0].name;
                if (e.target.files[0].name.length - ext.length > 15) {
                    fileName = e.target.files[0].name.slice(0, 15).concat('...').concat(ext);
                }

                $(this).closest('.input-file-section').children('.file-name').html(fileName);
            }
        });
    }
};

export default forms;