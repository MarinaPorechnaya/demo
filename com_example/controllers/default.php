<?php
//+_Поречная_***
defined( '_JEXEC' ) or die( 'Restricted access' );

class ExtControllersDefault extends JControllerBase
{
    public function execute()
    {
        // Get the application
        $app = $this->getApplication();
        
        // Get the document object.
        $document = $app->getDocument();
        
        $viewName = $app->input->getWord('view', 'dashboard');
        $viewFormat = $document->getType();
        $layoutName = $app->input->getWord('layout', 'default');
        
        $app->input->set('view', $viewName);
        
        // Register the layout paths for the view
        $paths = new SplPriorityQueue;
        $paths->insert(JPATH_COMPONENT . '/views/' . $viewName . '/tmpl', 'normal');
        
        $viewClass = 'ExtViews' . ucfirst($viewName) . ucfirst($viewFormat);
        $modelClass = 'ExtModels' . ucfirst($viewName);
        
        if (false === class_exists($modelClass))
        {
            $modelClass = 'ExtModelsDefault';
        }
        
        $view = new $viewClass(new $modelClass, $paths);
        $view->setLayout( $layoutName );
        
        // Render our view.
        echo $view->render();
        
        return true;
    }
}