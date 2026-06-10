<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Product;
use app\services\Product\BrandPriceService\BrandPriceService;
use app\services\Product\ProductCreateService;
use app\services\Product\ProductUpdateService;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

final class ProductController extends Controller
{
    public function __construct(
        $id,
        $module,
        private readonly ProductCreateService $productCreateService,
        private readonly ProductUpdateService $productUpdateService,
        private readonly BrandPriceService $brandPrices,
        $config = [],
    ) {
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['http://localhost:5173'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PATCH', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'only' => ['create', 'update'],
        ];

        return $behaviors;
    }

    /** GET /api/products */
    public function actionIndex(): array
    {
        return Product::find()->all();
    }

    /** GET /api/product/{id} */
    public function actionView(int $id): Product
    {
        return $this->findModel($id);
    }

    /** POST /api/product/create */
    public function actionCreate(): Product|array
    {
        $product = $this->productCreateService->create(\Yii::$app->request->bodyParams);

        if ($product->hasErrors()) {
            return $this->validationFailed($product);
        }

        \Yii::$app->response->setStatusCode(201);
        return $product;
    }

    /** PATCH /api/product/update/{id} */
    public function actionUpdate(int $id): Product|array
    {
        $product = $this->productUpdateService->update($this->findModel($id), \Yii::$app->request->bodyParams);

        if ($product->hasErrors()) {
            return $this->validationFailed($product);
        }

        return $product;
    }

    /** GET /api/product/brand/{name} */
    public function actionBrand(string $name): array
    {
        $result = $this->brandPrices->getMinMax($name);

        if ($result === null) {
            // Requirement 4: 404 when nothing is found
            throw new NotFoundHttpException("Товары бренда \"{$name}\" не найдены.");
        }

        return $result;
    }

    private function findModel(int $id): Product
    {
        $product = Product::findOne($id);

        if ($product === null) {
            throw new NotFoundHttpException("Товар с ID {$id} не найден.");
        }

        return $product;
    }

    private function validationFailed(Product $product): array
    {
        \Yii::$app->response->setStatusCode(422);

        return array_map(
            static fn(string $field, array $messages): array => [
                'field' => $field,
                'message' => $messages[0],
            ],
            array_keys($product->getErrors()),
            $product->getErrors(),
        );
    }
}
