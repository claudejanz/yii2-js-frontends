/**
 * @link https://www.klod.ch
 * @copyright Copyright (c) 2018 Klod SA
 * @author Claude Janz <claude.janz@klod.ch>
 */

import Api from '@/services/Api'

export default {
  index () {
    return Api().get('users/index')
  },
  login (credentials) {
    return Api().post('users/login', credentials)
  },
  register (user) {
    return Api().post('services/register', user)
  }
}
