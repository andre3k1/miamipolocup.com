# Load DSL and set up stages
require 'capistrano/setup'

# Include default deployment tasks
require 'capistrano/deploy'

# Load tasks from gems
require 'capistrano/composer'

# Ref: http://github.com/bkeepers/dotenv
require 'dotenv'
Dotenv.load

# Loads custom tasks from 'lib/capistrano/tasks' if you have any defined.
Dir.glob('lib/capistrano/tasks/*.rake').each { |r| import r }
