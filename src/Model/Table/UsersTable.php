<?php
namespace App\Model\Table;
use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
/**
 * Users Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Roles
 */
class UsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->getTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
        
        $this->hasOne('UserProfile', [
            'foreignKey' => 'user_id',
            'joinType' => 'LEFT'
        ]);
        


    }
    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        
        return $validator;
    }
    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['username']));
        
        return $rules;
    }
    public function findAuth(\Cake\ORM\Query $query, array $options){
        return $query->where(
            [
                'OR' => [
                    $this->aliasField('email') => $options['username'],
                ]
            ],
            [],
            true
        );
    }
	
	
}
