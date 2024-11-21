$(document).ready(function () {
	// 실시간 랭킹 top5 active이벤트
	let idx = 0;
	let rank_a_f = $('.live_rank_wrap li:first-child a');
	rank_a_f.addClass('cont4_active');
	rank_a_f.find('p').css({ color: '#333' });
	rank_a_f.find('#arrow').attr('src', './images/arrow_side_black.svg');
	function act1() {
		let rank_a = $('.live_rank_wrap a');
		$('.live_rank_wrap li a').removeClass('cont4_active');
		rank_a.find('p').css({ color: '#a2a2a2' });
		rank_a.find('#arrow').attr('src', './images/arrow_side_white.svg');
		if (idx == 0) {
			idx = 4;
			rank_a.removeClass('cont4_active');
		} else {
			idx--;
		}

		rank_a.eq(idx).addClass('cont4_active');
		rank_a.eq(idx).find('#arrow').attr('src', './images/arrow_side_black.svg');
		rank_a.eq(idx).find('p').css({ color: '#333' });
	}
	setInterval(act1, 3500);

	// 탑버튼 자연스럽게 보여지고 사라지기
	$(window).scroll(function () {
		if ($(this).scrollTop() > 200) {
			$('#top_btn, .custom-button').fadeIn(500);
		} else {
			$('#top_btn, .custom-button').fadeOut(500);
		}
	});

	//탑버튼 클릭이벤트 중복방지 animate
	$('#top_btn')
		.off('click')
		.on('click', function () {
			$('html, body').animate(
				{
					scrollTop: 0,
				},
				100
			);
			return false;
		});
});
