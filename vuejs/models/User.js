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
 * User model
 */
export class User extends Model {
  // Default attributes that define the "empty" state.
  defaults () {
    return {
      id: null,
      username: null,
      password_hash: null,
      password_reset_token: null,
      email: null,
      auth_key: null,
      role: null,
      status: null,
      created_at: null,
      updated_at: null
    }
  }

  // Attribute mutations.
  mutations () {
    return {
      id: (id) => Number(id) || null,
      username: String,
      role: String
    }
  }

  // Attribute validation
  validation () {
    return {
      id: integer.and(min(1)).or(equal(null)),
      username: string.and(required),
      role: string
    }
  }

  // Route configuration
  routes () {
    return {
      fetch: config.apiBaseUrl + 'users/view/{id}',
      save: config.apiBaseUrl + 'users/update/{id}'
    }
  }
}

/**
 * User collection
 */
export class Users extends Collection {
  // Model that is contained in this collection.
  model () {
    return User
  }

  // Default attributes
  defaults () {
    return {
      orderBy: 'title'
    }
  }

  // Route configuration
  routes () {
    return {
      fetch: config.apiBaseUrl + 'users/index'
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
