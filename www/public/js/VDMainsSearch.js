function searchVD() {
    const stateObj = {
        foo: "bar",
    };

    $OVD_DELA = document.getElementById('OVD_DELA').value;
    $N_KUSP = document.getElementById('N_KUSP').value;
    $N_UD = document.getElementById('N_UD').value;
    $DT_KUSP_FROM = document.getElementById('DT_KUSP_FROM').value;
    $DT_KUSP_TO = document.getElementById('DT_KUSP_TO').value;

    $newUrl = '/mains?page=1' + '&OVD_DELA=' + $OVD_DELA + '&N_KUSP=' + $N_KUSP + '&N_UD=' + $N_UD + '&DT_KUSP_FROM=' + $DT_KUSP_FROM + '&DT_KUSP_TO=' + $DT_KUSP_TO;

    history.pushState(stateObj, "page 2", $newUrl);
    location.reload();
}
