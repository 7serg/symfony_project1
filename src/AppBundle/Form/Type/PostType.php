<?php 

namespace AppBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;





class PostType extends AbstractType{
	public function buildForm(FormBuilderInterface $build, array $options)
	{
		$submit = isset($options['label']) ? $options['label'] : 'save';
		$build
			->add('title')
            ->add('content')
            ->add('imageFile', null, ['label'=>"Image"])
            ->add($submit,SubmitType::class);
}
}



 ?>