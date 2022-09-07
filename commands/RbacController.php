<?php

namespace app\commands;

use app\models\User;
use app\rbac\CustomerIsCreatorOfNewTaskRule;
use app\rbac\CustomerIsTaskCreatorRule;
use app\rbac\PerformerResponseRule;
use app\rbac\TaskPerformerRule;
use Yii;
use yii\base\Exception;
use yii\console\Controller;

class RbacController extends Controller
{
    /**
     * @return void
     * @throws Exception
     */
    public function actionInit(): void
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $performerResponseRule = new PerformerResponseRule();
        $customerIsTaskCreatorRule = new CustomerIsTaskCreatorRule();
        $customerIsCreatorOfNewTaskRule = new CustomerIsCreatorOfNewTaskRule();
        $taskPerformerRule = new TaskPerformerRule();
        $customerViewResponseRule = new

        $auth->add($performerResponseRule);
        $auth->add($customerIsTaskCreatorRule);
        $auth->add($customerIsCreatorOfNewTaskRule);
        $auth->add($taskPerformerRule);

        // customer rules
        $customerCanAcceptResponse = $auth->createPermission('customerCanAcceptResponse');
        $customerCanAcceptResponse->description = 'Customer can accept task response';
        $customerCanAcceptResponse->ruleName = $customerIsCreatorOfNewTaskRule->name;
        $auth->add($customerCanAcceptResponse);

        $customerCanRefuseResponse = $auth->createPermission('customerCanRefuseResponse');
        $customerCanRefuseResponse->description = 'Customer can refuse task response';
        $customerCanRefuseResponse->ruleName = $customerIsCreatorOfNewTaskRule->name;
        $auth->add($customerCanRefuseResponse);

        $customerCanCancelTask = $auth->createPermission('customerCanCancelTask');
        $customerCanCancelTask->description = 'Customer can cancel task';
        $customerCanCancelTask->ruleName = $customerIsCreatorOfNewTaskRule->name;
        $auth->add($customerCanCancelTask);

        $customerCanCreateReview = $auth->createPermission('customerCanCreateReview');
        $customerCanCreateReview->description = 'Customer can create review for finished task';
        $customerCanCreateReview->ruleName = $customerIsTaskCreatorRule->name;
        $auth->add($customerCanCreateReview);

        $customerCanCreateTask = $auth->createPermission('customerCanCreateTask');
        $customerCanCreateTask->description = 'Customer can create new task';
        $auth->add($customerCanCreateTask);

        // performer rules
        $performerCanCreateResponse = $auth->createPermission('performerCanCreateResponse');
        $performerCanCreateResponse->description = 'performer can create response for task';
        $performerCanCreateResponse->ruleName = $performerResponseRule->name;
        $auth->add($performerCanCreateResponse);

        $performerCanRefuseTask = $auth->createPermission('performerCanRefuseTask');
        $performerCanRefuseTask->description = 'performer can refuse task';
        $performerCanRefuseTask->ruleName = $taskPerformerRule->name;
        $auth->add($performerCanRefuseTask);

        // customer role
        $customer = $auth->createRole('customer');
        $auth->add($customer);
        $auth->addChild($customer, $customerCanAcceptResponse);
        $auth->addChild($customer, $customerCanRefuseResponse);
        $auth->addChild($customer, $customerCanCreateReview);
        $auth->addChild($customer, $customerCanCreateTask);
        $auth->addChild($customer, $customerCanCancelTask);

        // performer role
        $performer = $auth->createRole('performer');
        $auth->add($performer);
        $auth->addChild($performer, $performerCanCreateResponse);
        $auth->addChild($performer, $performerCanRefuseTask);

        $users = User::find()->all();

        foreach ($users as $user) {
            if ($user->is_performer === User::ROLE_CUSTOMER) {
                $auth->assign($customer, $user->id);
            } else {
                $auth->assign($performer, $user->id);
            }
        }
    }
}