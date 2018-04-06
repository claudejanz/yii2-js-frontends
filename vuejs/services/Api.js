/**
 * @link https://www.klod.ch
 * @copyright Copyright (c) 2018 Klod SA
 * @author Claude Janz <claude.janz@klod.ch>
 */
import Vue from 'vue'
import config from '@/../config/config.json'
import axios from 'axios'

export default () => {
  return axios.create({
    baseURL: config.apiBaseUrl,
    headers: {
      'Access-Control-Allow-Origin': '*',
      'Access-Control-Allow-Headers': '*'
    }
  })
}
