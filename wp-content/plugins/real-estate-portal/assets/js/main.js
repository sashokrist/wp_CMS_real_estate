(function($){
    $(document).on('click', '.rep-read-more', function(e){
        e.preventDefault();
        var $btn = $(this);
        var $wrap = $btn.closest('.rep-news-excerpt');
        var expanded = $btn.attr('data-expanded') === 'true';
        if (expanded) {
            $wrap.find('.rep-news-more').slideUp(150);
            $btn.text('Read more').attr('data-expanded', 'false');
        } else {
            $wrap.find('.rep-news-more').slideDown(150);
            $btn.text('Read less').attr('data-expanded', 'true');
        }
    });
})(jQuery);