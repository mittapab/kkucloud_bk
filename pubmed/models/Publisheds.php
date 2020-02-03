<?php

namespace backend\modules\pubmed\models;

use Yii;

/**
 * This is the model class for table "publisheds".
 *
 * @property int $id
 * @property string $PMID
 * @property string $owner
 * @property string $status
 * @property string $date_last_revised
 * @property string $date_of_publication
 * @property string $title
 * @property string $abstract
 * @property string $copyright_Information
 * @property string $language
 * @property string $publication_type
 * @property string $date_of_electronic_publication
 * @property string $place_of_publication
 * @property string $journal_Title_abbreviation
 * @property string $journal_title
 * @property string $NLM_Unique_ID
 * @property string $subset
 * @property string $entrez_date
 * @property string $MeSH_date
 * @property string $create_date
 * @property string $publication_status
 * @property string $source
 */
class Publisheds extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'publisheds';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'abstract', 'copyright_Information', 'journal_title', 'source'], 'string'],
            [['PMID', 'owner', 'date_last_revised'], 'string', 'max' => 50],
            [['status', 'language', 'publication_type', 'date_of_electronic_publication', 'place_of_publication', 'journal_Title_abbreviation', 'publication_status'], 'string', 'max' => 255],
            [['date_of_publication', 'NLM_Unique_ID', 'subset'], 'string', 'max' => 100],
            [['entrez_date', 'MeSH_date', 'create_date'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'PMID' => 'Pmid',
            'owner' => 'Owner',
            'status' => 'Status',
            'date_last_revised' => 'Date Last Revised',
            'date_of_publication' => 'Date Of Publication',
            'title' => 'Title',
            'abstract' => 'Abstract',
            'copyright_Information' => 'Copyright Information',
            'language' => 'Language',
            'publication_type' => 'Publication Type',
            'date_of_electronic_publication' => 'Date Of Electronic Publication',
            'place_of_publication' => 'Place Of Publication',
            'journal_Title_abbreviation' => 'Journal Title Abbreviation',
            'journal_title' => 'Journal Title',
            'NLM_Unique_ID' => 'Nlm Unique ID',
            'subset' => 'Subset',
            'entrez_date' => 'Entrez Date',
            'MeSH_date' => 'Me Sh Date',
            'create_date' => 'Create Date',
            'publication_status' => 'Publication Status',
            'source' => 'Source',
        ];
    }
}
