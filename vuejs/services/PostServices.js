/**
 * @link https://www.klod.ch
 * @copyright Copyright (c) 2018 Klod SA
 * @author Claude Janz <claude.janz@klod.ch>
 */

import Api from '@/services/Api'

export default {
  index () {
    return Api().get('posts/insex')
  },
  create (post) {
    console.log(post)
    return Api().post('posts/create', post)
  },
  view (id) {
    return Api().get('posts/view?id=' + id + '&expand=comments')
  }
}
