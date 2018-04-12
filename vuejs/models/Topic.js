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
 * Topic model
 */
export class Topic extends Model {
  // Default attributes that define the "empty" state.
  defaults () {
    return {
      id: null,
      title: '',
      created_at: '',
      updated_at: '',
      can_update: false
    }
  }

  // Attribute mutations.
  mutations () {
    return {
      id: (id) => Number(id) || null,
      title: String
    }
  }

  // Attribute validation
  validation () {
    return {
      id: integer.and(min(1)).or(equal(null)),
      title: string.and(required)
    }
  }

  // Route configuration
  routes () {
    return {
      fetch: config.apiBaseUrl + 'topics/{id}?expand=posts',
      update: config.apiBaseUrl + 'topics/{id}',
      create: config.apiBaseUrl + 'topics'
    }
  }
}

/**
 * Topic collection
 */
export class Topics extends Collection {
  // Model that is contained in this collection.
  model () {
    return Topic
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
      fetch: config.apiBaseUrl + 'topics'
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
