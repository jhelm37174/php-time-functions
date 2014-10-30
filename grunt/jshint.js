module.exports = function (grunt) {
  return {
    options: {
      jshintrc: '.jshintrc'
    },
    src: ['gruntfile.js', 'grunt/*.js']
  };
};
