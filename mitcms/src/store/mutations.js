/**
 * Created by weiai on 2018/3/15.
 */
import * as types from './mutation-types'

const mutations = {
  [types.SET_LOGIN_SHOW](state,isShow) {
    state.loginShow = isShow
  }
}

export default mutations