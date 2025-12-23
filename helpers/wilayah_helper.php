<?php

/**
 * Helper functions untuk endpoint-endpoint wilayah
 */

/**
 * Get URL untuk mengambil provinsi berdasarkan ID
 */
function getApiUrlProvinsiById($id) {
    return str_replace('{id}', $id, API_WILAYAH_PROVINSI);
}

/**
 * Get URL untuk mengambil kabupaten berdasarkan ID provinsi
 */
function getApiUrlKabupatenByProvinsi($provinsiId) {
    return str_replace('{provinsi_id}', $provinsiId, API_WILAYAH_KABUPATEN);
}

/**
 * Get URL untuk mengambil kecamatan berdasarkan ID kabupaten
 */
function getApiUrlKecamatanByKabupaten($kabupatenId) {
    return str_replace('{kabupaten_id}', $kabupatenId, API_WILAYAH_KECAMATAN);
}

/**
 * Get URL untuk mengambil desa berdasarkan ID kecamatan
 */
function getApiUrlDesaByKecamatan($kecamatanId) {
    return str_replace('{kecamatan_id}', $kecamatanId, API_WILAYAH_DESA);
}

/**
 * Get URL untuk mengambil detail wilayah berdasarkan ID desa
 */
function getApiUrlWilayahDetailByDesa($desaId) {
    return str_replace('{desa_id}', $desaId, API_WILAYAH_DETAIL);
}

/**
 * Get URL untuk mengambil hirarki wilayah berdasarkan ID desa
 */
function getApiUrlWilayahHierarchyByDesa($desaId) {
    return str_replace('{desa_id}', $desaId, API_WILAYAH_HIERARCHY);
}

/**
 * Get URL untuk mengupdate wilayah berdasarkan ID
 */
function getApiUrlUpdateWilayah($id) {
    return str_replace('{id}', $id, API_WILAYAH_ALL);
}

/**
 * Get URL untuk menghapus wilayah berdasarkan ID
 */
function getApiUrlDeleteWilayah($id) {
    return str_replace('{id}', $id, API_WILAYAH_ALL);
}