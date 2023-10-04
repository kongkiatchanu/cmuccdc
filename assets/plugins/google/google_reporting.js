$(function () {
    //google analytics reporting api v4
    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }
    var link_1hr = "https://www.googleapis.com/analytics/v3/data/ga?ids=ga%3A208306526&start-date=2019-12-20&end-date=today&metrics=ga%3Asessions&access_token=ya29.ImC6B0qvca4LNEa9XxYpvK_57ZX9plk_gPhJo85MeKOzbISM9yUHHN03ZUZlX66jzOImT11bdWxH9uVBVLyhLFlcZWeil1CZajAwqSL_2elxxmRKBMC7z8esAJRUUSl9vIM";
    $(function () {
        $.getJSON(link_1hr, function (data, textStatus, jqXHR) {
            var page_views = data.rows[0][0];
            if (page_views) {
                $('.page_views').html('<i class="fas fa-users"></i> <span>จำนวนผู้เข้าชม : ' + formatNumber(page_views) + '</span>');
            }
        });
    });
});