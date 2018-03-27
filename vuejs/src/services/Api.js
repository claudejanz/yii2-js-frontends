/**
 * @link https://www.klod.ch
 * @copyright Copyright (c) 2018 Klod SA
 * @author Claude Janz <claude.janz@klod.ch>
 */

import axios from 'axios'
import config from '@/../../config/config.json'

export default () => {
  return axios.create({
    baseURL: config.apiBaseUrl,
    headers: {
      'Access-Control-Allow-Origin': '*',
      'Access-Control-Allow-Headers': '*'
    }
  })
}
