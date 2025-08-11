// Live preview updates in Customizer
( function( api ) {
    // Hero Title
    api( 'rep_hero_title', function( value ) {
        value.bind( function( newVal ) {
            var el = document.querySelector('.rep-hero .rep-hero-inner h1');
            if (el) el.textContent = newVal && newVal.length ? newVal : document.title;
        } );
    } );
    // Hero Subtitle
    api( 'rep_hero_subtitle', function( value ) {
        value.bind( function( newVal ) {
            var el = document.querySelector('.rep-hero .rep-subtitle');
            if (el) el.textContent = newVal && newVal.length ? newVal : '';
        } );
    } );
    // Gradient From
    api( 'rep_hero_grad_from', function( value ) {
        value.bind( function( newVal ) {
            var section = document.querySelector('.rep-hero');
            if (section) {
                var to = wp.customize && wp.customize.value('rep_hero_grad_to') ? wp.customize.value('rep_hero_grad_to')() : '#1a2a3f';
                section.style.background = 'linear-gradient(135deg,' + newVal + ',' + to + ')';
            }
        } );
    } );
    // Gradient To
    api( 'rep_hero_grad_to', function( value ) {
        value.bind( function( newVal ) {
            var section = document.querySelector('.rep-hero');
            if (section) {
                var from = wp.customize && wp.customize.value('rep_hero_grad_from') ? wp.customize.value('rep_hero_grad_from')() : '#0e1520';
                section.style.background = 'linear-gradient(135deg,' + from + ',' + newVal + ')';
            }
        } );
    } );
} )( wp.customize );