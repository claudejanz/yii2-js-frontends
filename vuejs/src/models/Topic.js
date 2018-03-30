import {Model, Collection} from 'vue-mc'
import config from '@/../../config/config.json'
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
      title: null,
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
      fetch: '/topics/{id}',
      save: '/topics/update/{id}'
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
      fetch: config.apiBaseUrl + 'topics/index'
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
