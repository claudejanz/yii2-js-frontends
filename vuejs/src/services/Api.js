/**
 * @link https://www.klod.ch
 * @copyright Copyright (c) 2018 Klod SA
 * @author Claude Janz <claude.janz@klod.ch>
 */

import axios from 'axios'

export default () => {
  return axios.create({
    baseURL: `http://api.yii2-js-frontends.local/`,
    headers: {
      'Access-Control-Allow-Origin': '*',
      'Access-Control-Allow-Headers': '*',
      'Content-Type': 'application/json'
    }
  })
}
