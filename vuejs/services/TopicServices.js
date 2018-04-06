/**
 * @link https://www.klod.ch
 * @copyright Copyright (c) 2018 Klod SA
 * @author Claude Janz <claude.janz@klod.ch>
 */

import Api from '@/services/Api'

export default {
  index () {
    return Api().get('topics/index')
  },
  create (topic) {
    return Api().post('topics/create', topic)
  },
  view (id) {
    return Api().get('topics/view?id=' + id + '&expand=posts')
  }
}
