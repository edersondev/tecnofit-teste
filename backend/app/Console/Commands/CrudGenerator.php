<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CrudGenerator extends Command
{
  const VAR_MODEL_NAME = '{{modelName}}';
  protected $name;

  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'crud:generator
  {name : Class (singular) for example User}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Create CRUD operations';

  /**
   * Execute the console command.
   *
   * @return void
   */
  public function handle()
  {
    $this->name = $this->argument('name');
    
    $this->request();
    $this->controller();
    $this->service();
    $this->repository();
    $this->model();
  }

  private function getStub($type)
  {
    return file_get_contents(app_path("stubs/$type.stub"));
  }

  private function request()
  {
    $requestTemplate = str_replace([self::VAR_MODEL_NAME],[$this->name],$this->getStub('Request'));
    if(!file_exists($path = app_path('/Http/Requests'))){
      mkdir($path, 0755, true);
    }
    file_put_contents(app_path("/Http/Requests/{$this->name}Request.php"), $requestTemplate);
  }

  private function controller()
  {
    $controllerTemplate = str_replace(self::VAR_MODEL_NAME,$this->name,$this->getStub('Controller'));
    file_put_contents(app_path("/Http/Controllers/{$this->name}Controller.php"), $controllerTemplate);
  }

  private function service()
  {
    $controllerTemplate = str_replace(self::VAR_MODEL_NAME,$this->name,$this->getStub('Service'));
    file_put_contents(app_path("/Http/Services/{$this->name}Service.php"), $controllerTemplate);
  }

  private function repository()
  {
    $snakeCase = Str::of($this->name)->snake();
    $controllerTemplate = str_replace(
      [self::VAR_MODEL_NAME,'{{modelNameSingularLowerCase}}'],
      [$this->name,strtolower($snakeCase)],
      $this->getStub('Repository')
    );
    file_put_contents(app_path("/Repository/{$this->name}Repository.php"), $controllerTemplate);
  }

  protected function model()
  {
    $dbConnection = config('database.default');
    $arrConnections = config('database.connections');
    $schema = (isset($arrConnections[$dbConnection]['prefix_schema']) ? $arrConnections[$dbConnection]['prefix_schema'] : '');

    $snakeCase = Str::of($this->name)->snake();

    $modelTemplate = str_replace(
      [self::VAR_MODEL_NAME,'{{modelNameSingularLowerCase}}','{{schema}}'],
      [$this->name,strtolower($snakeCase),$schema],
      $this->getStub('Model')
    );
    file_put_contents(app_path("Models/{$this->name}.php"), $modelTemplate);
  }
}
