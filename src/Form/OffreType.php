<?php

namespace App\Form;

use App\Entity\Domaine;
use App\Entity\Offre;
use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre_offre')

            ->add('region_offre')
            ->add('description')
            ->add('exigences')
            ->add('date_expiration', DateTimeInterface::class)
            ->add('societe')
            ->add('postesVacants')
            ->add('niveauEtude')
            ->add('typeEmploiDesire')
            ->add('langue')
            ->add('experience')
            ->add('genre')
            ->add('image', filetype::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}
