<template>
  <div>
    <div v-if="post">
      <panel :title="post.title">
        <v-layout>
          <v-flex xs6>
            <div v-html="post.content" />
            <div v-if="!comments">
              <v-btn :to="{name:&quot;posts-id&quot;,params:{&quot;id&quot;:post.id}}">View
              </v-btn>
            </div>
          </v-flex>
          <v-flex xs6>
            <panel v-if="comments"
                   :title="&quot;Comments &quot;+comments.models.length">
              <v-expansion-panel>
                <v-expansion-panel-content v-for="(comment) in comments.models"
                                           :key="comment.id">
                  <div slot="header">
                    <v-chip class="white elevation-1">
                      <v-avatar class="teal elevation-3">
                        <v-icon>account_box</v-icon>
                      </v-avatar>
                      {{ comment.username }} | {{ comment.created_at | date }}
                    </v-chip>
                  </div>
                  <div v-html="comment.content"
                       class="mx-4" />
                </v-expansion-panel-content>
              </v-expansion-panel>
            </panel>
          </v-flex>
        </v-layout>
      </panel>
    </div>
    <div v-else>
      <v-icon class="spin">cached</v-icon>
    </div>
    <v-divider v-if="index!=undefined && index + 1 < max" />
  </div>
</template>

<script>
import Panel from '@/components/Panel';
import {Post} from '@/models/Post';
import {Comments} from '@/models/Comment';
import CommentView from '@/components/comments/View';

export default {
  components: {
    Panel,
    CommentView
  },
  props: ['postFromParent', 'index', 'max'],
  data() {
    return {
      error: null,
      postFromLoad: null
    };
  },
  computed: {
    comments: function() {
      if (this.post && this.post.comments) {
        return new Comments(this.post.comments);
      } else {
        return null;
      }
    },
    post: function() {
      return this.postFromLoad ? this.postFromLoad : this.postFromParent;
    }
  },
  async created() {
    if (this.postFromParent === undefined) {
      this.init();
    }
  },
  methods: {
    async init() {
      try {
        const post = new Post({ id: this.$route.params.id });
        await post.fetch();
        this.postFromLoad = post;
        this.error = null;
      } catch (error) {
        this.post = null;
        this.error = error.response.error;
      }
    }
  }
};
</script>
