<?php

// src/Form/ProfileType.php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use App\Entity\Profile;
use App\Entity\Artisan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Ajouter des champs au formulaire
        $builder
            ->add('specialite')
            ->add('description')
            ->add('experience')
            ->add('tarifHoraire')
            ->add('localisation')
            ->add('disponibilite')
            ->add('image', FileType::class, [
                'label' => 'Image (JPG, PNG)',
                'required' => true,
                'mapped' => false,  // Ne lie pas ce champ à une propriété de l'entité Profile
                'attr' => ['class' => 'form-control border-0 shadow-sm p-3']
            ])
           
            ->add('artisan', ChoiceType::class, [
                'choices' => $options['artisans'],
                'choice_label' => function(Artisan $artisan) {
                    return $artisan->getFullName(); // Assurez-vous que cette méthode existe dans Artisan
                },
                'placeholder' => 'Choisir un artisan', // Optionnel pour afficher un champ vide au début
            ])
           ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
            'artisans' => [],  // Vous passerez ici la liste des artisans lors de la création du formulaire
        ]);
    }
}
