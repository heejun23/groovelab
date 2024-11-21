$(document).ready(function(){
  $('.qna_ajax_tab a').click(function(e){
    e.preventDefault();

    let url = $(this).attr('href');
    console.log(url);

    $('.qna_ajax_tab a.qna_tab_on').removeClass('qna_tab_on');
    $(this).addClass('qna_tab_on');

    $('.qna_table_wrap').remove();
    //$('.qna_table_wrap').load(`${url} +  .qna_contents`).hide().fadeIn();
    $('.big_box').load(url + ' .qna_table_wrap').hide().fadeIn();
  });
})//juqey