import store from '@/store/index'
// import axios from '../http'
// import api from '@/api/api'
import { USER_SIGNIN, USER_SIGNOUT, USER_INFO, CLEAR_PREV_URL_NAME } from '@/store/mutation-types'

var mallache = {}
mallache.write_token = function (token) {
  // 写入localStorage
  store.commit(USER_SIGNIN, token)
}

mallache.write_user = function (user) {
  var userInfo = {
    id: user.id,
    phone: user.phone,
    type: user.type,
    role_id: user.role_id,
    verify_status: user.verify_status,
    distributor_status: user.distributor_status,
    mould_id: user.mould_id,
    status: user.status
  }
  // 写入localStorage
  store.commit(USER_INFO, userInfo)
}

mallache.logout = function () {
  store.commit(USER_SIGNOUT)
}

mallache.clear_prev_url_name = function () {
  store.commit(CLEAR_PREV_URL_NAME)
}

export default mallache
