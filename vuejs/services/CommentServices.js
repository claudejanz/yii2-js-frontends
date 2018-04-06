/**
 * @link https://www.klod.ch
 * @copyright Copyright (c) 2018 Klod SA
 * @author Claude Janz <claude.janz@klod.ch>
 */

import Api from '@/services/Api'

export default {
  index () {
    return Api().get('comments/insex')
  },
  create (post) {
    console.log(post)
    return Api().post('comments/create', post)
  },
  view (id) {
    return Api().get('comments/view?id=' + id + '&expand=comments')
  }
}
