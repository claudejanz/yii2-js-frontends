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
 * Post model
 */
export class Post extends Model {
  // Default attributes that define the "empty" state.
  defaults () {
    return {
      id: null,
      title: null,
      content: null,
      created_at: null,
      updated_at: null
    }
  }

  // Attribute mutations.
  mutations () {
    return {
      id: (id) => Number(id) || null,
      title: String,
      content: String
    }
  }

  // Attribute validation
  validation () {
    return {
      id: integer.and(min(1)).or(equal(null)),
      title: string.and(required),
      content: string.and(required)
    }
  }

  // Route configuration
  routes () {
    return {
      fetch: config.apiBaseUrl + 'posts/{id}?expand=comments',
      save: config.apiBaseUrl + 'posts/{id}'
    }
  }
}

/**
 * Post collection
 */
export class Posts extends Collection {
  // Model that is contained in this collection.
  model () {
    return Post
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
      fetch: config.apiBaseUrl + 'posts'
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
