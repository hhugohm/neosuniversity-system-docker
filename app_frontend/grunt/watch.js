module.exports = {
  less: {
	  files: ['src/css/less/*.less'],
	  tasks: ['recess'],
  },

   scripts: {
    files: ['**/src/**/*.js'],
    tasks: ['copy:apache'],
    options: {
      spawn: false,
    },
  },

  html: {
     files: ['**/tpl/**/*.html'],
    tasks: ['copy:apache'],
  }
}
