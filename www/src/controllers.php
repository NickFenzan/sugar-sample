<?php
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

$app->match('/', function(Request $request) use ($app){
  $form = $app['form.factory']
        ->createBuilder(FormType::class)
        ->add('Text', TextType::class)
        ->add('File', FileType::class)
        ->getForm();

  $db_entries = $app['db']->fetchAll('SELECT * FROM test_table');

  if ($request->isMethod('POST')) {
    $form->handleRequest($request);
    if ($form->isValid()) {
      $formData = $form->getData();
      $app['db']->insert('test_table',array('name' => $formData['Text']));
      $files = ($request->files->get($form->getName()));
      $path = $app['upload_path'];
      $files['File']->move($path,'test.csv');
      $message = 'File was successfully uploaded!';
    }
  }

  return $app['twig']->render('test-page.html', array(
    'db_entries' => $db_entries,
    'form' => $form->createView(),
    'message' => $message
  ));
}, 'GET|POST');

$app->get('/test-file', function() use ($app) {
  $path = $app['upload_path'];
  $filename = 'test.csv';
  if (!file_exists($path . $filename)) {
    $app->abort(404);
  }

  return $app->sendFile($path . $filename)
  ->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename);
});
