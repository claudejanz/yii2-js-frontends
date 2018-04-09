import {Model, Collection} from 'vue-mc'
import config from '~/../config/config.json'

import {
  equal,
  integer,
  min,
  required,
  string
} from 'vue-mc/validation'
/**
 * Comment model
 */
export default class Comment extends Model {
  // Default attributes that define the "empty" state.
  defaults () {
    return {
      id: null,
      content: null,
      created_at: null,
      created_by: null,
      updated_at: null,
      updated_by: null,
      username: null
    }
  }

  // Attribute mutations.
  mutations () {
    return {
      id: (id) => Number(id) || null,
      content: String
    }
  }

  // Attribute validation
  validation () {
    return {
      id: integer.and(min(1)).or(equal(null)),
      content: string.and(required)
    }
  }

  // Route configuration
  routes () {
    return {
      fetch: config.apiBaseUrl + 'comments/{id}',
      save: config.apiBaseUrl + 'comments/{id}'
    }
  }
}

/**
 * Comment collection
 */
export class Comments extends Collection {
  // Model that is contained in this collection.
  model () {
    return Comment
  }

  // Default attributes
  defaults () {
    return {
      orderBy: 'content'
    }
  }

  // Route configuration
  routes () {
    return {
      fetch: config.apiBaseUrl + 'comments'
    }
  }

  // Number of users to be completed.
  get todo () {
    return this.sum('done')
  }

  // Will be `true` if all users have been completed.
  get done () {
    return this.todo === 0
  }
}
