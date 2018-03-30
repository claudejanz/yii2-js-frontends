/**
 * @link https://www.klod.ch
 * @copyright Copyright (c) 2018 Klod SA
 * @author Claude Janz <claude.janz@klod.ch>
 */
import Vue from 'vue'
import config from '@/../../config/config.json'
import axios from 'axios'
import CripLoading from 'crip-vue-loading'
Vue.use(CripLoading, {
  axios: axios,
  color: 'orange',
  height: '5px',
  // applyOnRouter: false,
  direction: 'right'
})
export default () => {
  return axios.create({
    baseURL: config.apiBaseUrl,
    headers: {
      'Access-Control-Allow-Origin': '*',
      'Access-Control-Allow-Headers': '*'
    }
  })
}
