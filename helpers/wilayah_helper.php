<?php








function getApiUrlProvinsiById($id) {
    return str_replace('{id}', $id, API_WILAYAH_PROVINSI);
}




function getApiUrlKabupatenByProvinsi($provinsiId) {
    return str_replace('{provinsi_id}', $provinsiId, API_WILAYAH_KABUPATEN);
}




function getApiUrlKecamatanByKabupaten($kabupatenId) {
    return str_replace('{kabupaten_id}', $kabupatenId, API_WILAYAH_KECAMATAN);
}




function getApiUrlDesaByKecamatan($kecamatanId) {
    return str_replace('{kecamatan_id}', $kecamatanId, API_WILAYAH_DESA);
}




function getApiUrlWilayahDetailByDesa($desaId) {
    return str_replace('{desa_id}', $desaId, API_WILAYAH_DETAIL);
}




function getApiUrlWilayahHierarchyByDesa($desaId) {
    return str_replace('{desa_id}', $desaId, API_WILAYAH_HIERARCHY);
}




function getApiUrlUpdateWilayah($id) {
    return str_replace('{id}', $id, API_WILAYAH_ALL);
}




function getApiUrlDeleteWilayah($id) {
    return str_replace('{id}', $id, API_WILAYAH_ALL);
}