<?php

namespace Vaszev\CrudBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Sensio\Bundle\GeneratorBundle\Command\GenerateDoctrineCrudCommand;
use Vaszev\CrudBundle\Generator\VaszevCrudGenerator;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

class CrudCommand extends GenerateDoctrineCrudCommand {
  protected $generator;
  protected $formGenerator;



  protected function configure() {
    parent::configure();

    $this->setName('vaszev:generate:crud');
    $this->setDescription('Modified Symfony3 CRUD generator.');
  }



  protected function createGenerator($bundle = null) {
    $rootDir = $this->getContainer()->getParameter('kernel.root_dir');
    return new VaszevCrudGenerator($this->getContainer()->get('filesystem'), $rootDir);
  }



  protected function getSkeletonDirs(BundleInterface $bundle = null) {
    $skeletonDirs = array();

    if (isset($bundle) && is_dir($dir = $bundle->getPath() . '/Resources/SensioGeneratorBundle/skeleton')) {
      $skeletonDirs[] = $dir;
    }

    if (is_dir($dir = $this->getContainer()->get('kernel')->getRootdir() . '/Resources/SensioGeneratorBundle/skeleton')) {
      $skeletonDirs[] = $dir;
    }

    $skeletonDirs[] = $this->getContainer()->get('kernel')->locateResource('@VaszevCrudBundle/Resources/skeleton');
    $skeletonDirs[] = $this->getContainer()->get('kernel')->locateResource('@VaszevCrudBundle/Resources');

    return $skeletonDirs;
  }



  protected function interact(InputInterface $input, OutputInterface $output) {
    if (method_exists($this, 'getDialogHelper')) {
      $dialog = $this->getDialogHelper();
    } else {
      $dialog = $this->getQuestionHelper();
    }

    $dialog->writeSection($output, 'VaszevCrudBundle');

    parent::interact($input, $output);
  }
}
