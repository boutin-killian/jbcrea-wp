import $ from 'jquery';

let admin = {

    load() {
        $(document).ready(function(){
            $('#timber_delete_cache').on('click', function(e){
                e.preventDefault();
                $(this).attr('disabled', 'disabled');
                $('#timber-action .spinner').addClass('is-active');

                var data = {
                    'action': 'admin_delete_timber_cache',
                    'security': admin_data.security
                };

                $.post(ajaxurl, data, function(response) {

                    if (response === 'DONE'){
                        console.info('Cache cleared');
                    }else {
                        console.error('Clear Cache Failed !');
                    }

                    $('#timber-action .spinner').removeClass('is-active');
                    $('#timber_delete_cache').removeAttr('disabled');
                });
            });
        });
    }
};

export default admin;