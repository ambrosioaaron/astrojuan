function astroBlock(blockID, blockText)
{
    $(blockID).children().hide();
    $(blockID).append('<h4 class="astroBlock" id=\'astroBlock\'>' + blockText + '</h4>')
}

function astroUnBlock(blockID) {
    $(blockID).children().show();
    $('#astroBlock').remove();
}