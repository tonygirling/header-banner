$header_text_src_desktop = document.querySelector('#themed-section-text-src-desktop');
$header_text_src_mobile = document.querySelector('#themed-section-text-src-mobile');

$header_text_div_desktop = document.querySelector('#themed-section-text-div-desktop');
$header_text_div_mobile = document.querySelector('#themed-section-text-div-mobile');

if ($header_text_src_desktop && $header_text_div_desktop ) {
    $header_text_div_desktop.innerHTML = $header_text_src_desktop.value;
}

if ($header_text_src_mobile && $header_text_src_mobile ) {
    $header_text_div_mobile.innerHTML = $header_text_src_mobile.value;
}


$bottom_right_cell = document.querySelector('.site-header-bottom-section-right');
$bottom_right_cell_contents = document.querySelector('#site-header-bottom-section-right');

$bottom_right_cell.innerHTML = '<div class="bottom-right-area">' + $bottom_right_cell_contents.value + '</div>' + $bottom_right_cell.innerHTML;