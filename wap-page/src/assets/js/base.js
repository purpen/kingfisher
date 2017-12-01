/* eslint-disable */
/*
 * phenix base js
 */
let phenix = {}

/**
 * 允许多附件上传
 */
phenix.record_asset_id = function (class_id, id) {
  let ids = $('#' + class_id).val()
  if (ids.length == 0) {
    ids = id
  } else {
    if (ids.indexOf(id) == -1) {
      ids += ',' + id
    }
  }
  $('#' + class_id).val(ids)
}

//移除附件id
phenix.remove_asset_id = function (class_id, id) {
  let ids = $('#' + class_id).val()
  let ids_arr = ids.split(',')
  let is_index_key = phenix.in_array(ids_arr, id)
  ids_arr.splice(is_index_key, 1)
  ids = ids_arr.join(',')
  $('#' + class_id).val(ids)
}

//查看字符串是否在数组中存在
phenix.in_array = function (arr, val) {
  let i
  for (i = 0; i < arr.length; i++) {
    if (val === arr[i]) {
      return i
    }
  }
  return -1
} // 返回-1表示没找到，返回其他值表示找到的索引
// 去重
phenix.unique = function (arr) {
  let res = []
  let json = {}
  for (let i of arr) {
    if (!json[i]) {
      res.push(i)
      json[i] = i
    }
  }
  return res
}
export default phenix
