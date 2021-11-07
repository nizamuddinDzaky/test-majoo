function sweet_alert(icon, title , text, showCancelButton =  false, cancelButtonText ='Tidak', confirmButtonText = 'OK', html = ''){
    return Swal.fire({
        title: title,
        icon: icon,
        html: text,
        reverseButtons: !0,
        showCancelButton : showCancelButton,
        cancelButtonText : cancelButtonText,
        confirmButtonText : confirmButtonText,
        allowOutsideClick: false,
    })
}

function loader(){
    return Swal.fire({
          title: 'Mohon Tunggu',
          width: 600,
          padding: '3em',
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });
}

function send_data(url, method, data){
    return new Promise((resolve, reject) => {
        $.ajax({
            url:url,
            data:data,
            cache: false,
            contentType: false,
            processData: false,
            type:method,
            dataType: 'html',
            beforeSend: function() {
                // loader()
            },
            complete:function() {
              
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                reject(err.Message)
            },
            success:function(data) {
                let res = JSON.parse(data)
                if(res.success == false){
                    reject(res.message)
                }
                resolve(res)
            }
        })
    });
}
(function($) {
    $.fn.toJSON = function() {
        var $elements = {};
        var $form = $(this);
        $form.find('input, select, textarea').each(function(){
          var name = $(this).attr('name')
          var type = $(this).attr('type')
          if(name){
            var $value;
            if(type == 'radio'){
              $value = $('input[name='+name+']:checked', $form).val()
            } else if(type == 'checkbox'){
              $value = $(this).is(':checked')
            } else {
              $value = $(this).val()
            }
            $elements[$(this).attr('name')] = $value
          }
        });
        return JSON.stringify( $elements )
    };
    $.fn.fromJSON = function(json_string) {
        var $form = $(this)
        var data = JSON.parse(json_string)
        let textarea = $form.find('textarea')
        textarea.val(data.description)
        $.each(data, function(key, value) {
          var $elem = $('[name="'+key+'"]', $form)
          var type = $elem.first().attr('type')
          let identifier = $elem.first().data('identifier')
          if(identifier != '' &&  identifier != undefined){
            if(identifier == 'formatrupiah')   {
                value = formatRupiah(value.toString(), 'Rp. ')
            }
          }
          if(type == 'radio'){
            $('[name="'+key+'"][value="'+value+'"]').prop('checked', true)
          } else if(type == 'checkbox' && (value == true || value == 'true')){
            $('[name="'+key+'"]').prop('checked', true)
          } else {
            $elem.val(value).trigger('change')
          }
        })
    };
}( jQuery ));

function collapse(content) {
    $content = $('.'+content);
    //open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
    $content.slideToggle(500, function () {});
}

$(document).ready(function(){
    $(document).on('submit', '#form', function () {
        var formData = new FormData(this);
        $.ajax({
            url:$(this).attr("action"),
            data:formData,
            cache: false,
            contentType: false,
            processData: false,
            type:$(this).attr("method"),
            dataType: 'html',
            beforeSend: function() {
                // loader()
            },
            complete:function() {
              
            },
            success:function(data) {
                let res = JSON.parse(data)
                if(res.success == false){
                    let _title = "Error";
                    if(res.title != false){
                        _title = res.title
                    }
                    sweet_alert("error", _title, res.message).then(function (e) {
                        if(res.title != false){
                            location.reload()
                        }
                        e.dismiss;
                    }, function (dismiss) {
                        return false;
                    })
                }else{
                    console.log(res);
                    sweet_alert("success", "Berhasil", res.message).then(function (e) {
                        window.location.href = res.data.url;
                    }, function (dismiss) {
                        return false;
                    })
                }
            }
        })
        return false
    })
})
function formatRupiah(angka, prefix){
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split   		= number_string.split(','),
    sisa     		= split[0].length % 3,
    rupiah     		= split[0].substr(0, sisa),
    ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
    if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}